// custom hook function from: https://devtrium.com/posts/how-keyboard-shortcut
import { useCallback, useEffect, useLayoutEffect, useRef } from 'react';

export default (callback, node = null) => {
  // implement the callback ref pattern
  const callbackRef = useRef(callback);
  useLayoutEffect(() => {
    callbackRef.current = callback;
  });

  // handle what happens on key press
  const handleKeyPress = useCallback((event) => {
    // check if one of the key is part of the ones we want
    callbackRef.current(event);
  }, []);

  useEffect(() => {
    // target is either the provided node or the document
    const targetNode = node ?? document;
    // attach the event listener
    targetNode && targetNode.addEventListener('keydown', handleKeyPress);

    // remove the event listener
    return () =>
      targetNode && targetNode.removeEventListener('keydown', handleKeyPress);
  }, [handleKeyPress, node]);
};
